package com.cctn.app.ui.profile

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.fragment.app.viewModels
import coil.load
import coil.transform.CircleCropTransformation
import com.cctn.app.R
import com.cctn.app.data.model.UpdateProfileRequest
import com.cctn.app.databinding.FragmentProfileBinding
import com.cctn.app.util.Result
import dagger.hilt.android.AndroidEntryPoint

@AndroidEntryPoint
class ProfileFragment : Fragment() {

    private var _binding: FragmentProfileBinding? = null
    private val binding get() = _binding!!
    private val viewModel: ProfileViewModel by viewModels()

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View {
        _binding = FragmentProfileBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        viewModel.loadProfile()

        viewModel.profile.observe(viewLifecycleOwner) { result ->
            if (result is Result.Success) {
                val c = result.data.client ?: return@observe
                binding.etFirstname.setText(c.firstname)
                binding.etMiddlename.setText(c.middlename)
                binding.etLastname.setText(c.lastname)
                binding.etEmail.setText(c.email)
                binding.etUsername.setText(c.username)
                binding.etContactNo.setText(c.contactNo)
                binding.etBirthdate.setText(c.birthdate)
                binding.tvAccountNumber.text = c.accountNumber
                c.profilePhoto?.let { url ->
                    binding.ivAvatar.load(url) {
                        crossfade(true)
                        transformations(CircleCropTransformation())
                        placeholder(R.drawable.ic_avatar_placeholder)
                    }
                }
            }
        }

        binding.btnSave.setOnClickListener {
            val request = UpdateProfileRequest(
                firstname  = binding.etFirstname.text.toString().trim(),
                middlename = binding.etMiddlename.text.toString().trim().ifEmpty { null },
                lastname   = binding.etLastname.text.toString().trim(),
                email      = binding.etEmail.text.toString().trim(),
                username   = binding.etUsername.text.toString().trim(),
                contactNo  = binding.etContactNo.text.toString().trim(),
                birthdate  = binding.etBirthdate.text.toString().trim().ifEmpty { null },
                newPassword = binding.etNewPassword.text.toString().trim().ifEmpty { null },
            )
            viewModel.updateProfile(request)
        }

        viewModel.updateResult.observe(viewLifecycleOwner) { result ->
            when (result) {
                is Result.Loading -> binding.btnSave.isEnabled = false
                is Result.Success -> {
                    binding.btnSave.isEnabled = true
                    Toast.makeText(requireContext(), "Profile updated successfully!", Toast.LENGTH_SHORT).show()
                }
                is Result.Error -> {
                    binding.btnSave.isEnabled = true
                    Toast.makeText(requireContext(), result.message, Toast.LENGTH_LONG).show()
                }
            }
        }
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}
