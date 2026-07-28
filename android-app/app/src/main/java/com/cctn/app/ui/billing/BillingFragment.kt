package com.cctn.app.ui.billing

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.fragment.app.viewModels
import androidx.recyclerview.widget.LinearLayoutManager
import com.cctn.app.databinding.FragmentBillingBinding
import com.cctn.app.util.Result
import dagger.hilt.android.AndroidEntryPoint

@AndroidEntryPoint
class BillingFragment : Fragment() {

    private var _binding: FragmentBillingBinding? = null
    private val binding get() = _binding!!
    private val viewModel: BillingViewModel by viewModels()
    private lateinit var adapter: BillingAdapter

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View {
        _binding = FragmentBillingBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        adapter = BillingAdapter()
        binding.rvBilling.layoutManager = LinearLayoutManager(requireContext())
        binding.rvBilling.adapter = adapter

        binding.swipeRefresh.setOnRefreshListener { viewModel.loadBilling() }

        viewModel.billing.observe(viewLifecycleOwner) { result ->
            binding.swipeRefresh.isRefreshing = result is Result.Loading
            when (result) {
                is Result.Success -> {
                    binding.tvBalance.text = "Outstanding Balance: ₱${String.format("%.2f", result.data.balance)}"
                    binding.emptyState.visibility =
                        if (result.data.statements.isEmpty()) View.VISIBLE else View.GONE
                    adapter.submitList(result.data.statements)
                }
                is Result.Error -> Toast.makeText(requireContext(), result.message, Toast.LENGTH_LONG).show()
                else -> {}
            }
        }

        viewModel.loadBilling()
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}
